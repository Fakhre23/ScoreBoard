<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Table: universities
        Schema::create('universities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country');
            $table->integer('total_score')->default(0);
            $table->string('UNI_photo')->nullable();
        });

        // Table: standard_user_role
        Schema::create('standard_user_role', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Admin', 'Ambassador', 'ViceAmbassador', 'Representative', 'Student']);
        });

        // Table: event_roles
        Schema::create('event_roles', function (Blueprint $table) {
            $table->id();
            $table->enum('name', ['Organizer', 'Booth', 'ContentCreation', 'MediaCoverage', 'Volunteer', 'Participant']);
            $table->integer('points_awarded');
        });

        // Modify: users table
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('university_id')->nullable()->after('id');
            $table->string('phone')->nullable()->after('email');
            $table->string('profile_photo')->nullable()->after('phone');
            $table->integer('total_user_score')->default(0)->after('profile_photo');
            $table->boolean('is_active')->default(true)->after('total_user_score');
            $table->unsignedBigInteger('user_role')->nullable()->after('is_active');

            $table->foreign('university_id')->references('id')->on('universities')->onDelete('set null');
            $table->foreign('user_role')->references('id')->on('standard_user_role')->onDelete('set null');
        });

        // Table: user_history
        Schema::create('user_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('role_id');
            $table->timestamp('start_date');
            $table->timestamp('end_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->enum('approval_status', ['Pending', 'Approved', 'Rejected']);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('standard_user_role')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });

        // Table: events
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->timestamp('start_datetime');
            $table->timestamp('end_datetime');
            $table->integer('max_participants');
            $table->unsignedBigInteger('created_by');
            $table->enum('status', ['Draft', 'PendingApproval', 'Approved', 'Rejected', 'Completed'])->default('Draft');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });

        // Table: score_claim
        Schema::create('score_claim', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('event_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('event_role_id');
            $table->enum('attendance_status', ['Registered', 'Attended', 'NoShow']);
            $table->integer('points_earned');
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamp('approval_date')->nullable();
            $table->text('feedback')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('event_role_id')->references('id')->on('event_roles')->onDelete('cascade');
            $table->foreign('approved_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Rollback in reverse order (important for foreign key dependencies)
        Schema::dropIfExists('score_claim');
        Schema::dropIfExists('events');
        Schema::dropIfExists('user_history');

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropForeign(['user_role']);
            $table->dropColumn([
                'university_id',
                'phone',
                'profile_photo',
                'total_user_score',
                'is_active',
                'user_role',
            ]);
        });

        Schema::dropIfExists('event_roles');
        Schema::dropIfExists('standard_user_role');
        Schema::dropIfExists('universities');
    }
};
