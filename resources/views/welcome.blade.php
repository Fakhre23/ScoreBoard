<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Competition Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">University Competition Platform</h1>
            <p class="text-lg text-gray-600 mb-6">Join the competition and earn points for your university!</p>
            
            {{-- Action Buttons --}}
            <div class="flex justify-center gap-4 mb-8">
                <a href="{{ route('register') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-all shadow-lg">
                    Register Now
                </a>
                <a href="{{ route('login') }}" 
                   class="bg-white hover:bg-gray-50 text-blue-600 font-semibold py-3 px-6 rounded-lg border-2 border-blue-600 transition-all">
                    Login
                </a>
            </div>
        </div>

        {{-- Leaderboards --}}
        <div class="grid md:grid-cols-2 gap-8">
            {{-- Top Users --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-yellow-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    Top Students
                </h2>
                <div class="space-y-3">
                    @foreach ($topUsers->take(10) as $index => $user)
                        <div class="flex items-center justify-between p-3 rounded-lg 
                            {{ $index === 0 ? 'bg-yellow-100 border border-yellow-300' : 
                               ($index === 1 ? 'bg-gray-100 border border-gray-300' : 
                               ($index === 2 ? 'bg-orange-100 border border-orange-300' : 'bg-gray-50')) }}">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $index === 0 ? 'bg-yellow-500 text-white' : 
                                       ($index === 1 ? 'bg-gray-500 text-white' : 
                                       ($index === 2 ? 'bg-orange-500 text-white' : 'bg-blue-500 text-white')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $user->university_id ?? 'No University' }}</p>
                                </div>
                            </div>
                            <span class="font-bold text-lg text-blue-600">{{ $user->total_user_score ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Top Universities --}}
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg class="w-6 h-6 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2H4zm2 3a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                    </svg>
                    Top Universities
                </h2>
                <div class="space-y-3">
                    @foreach ($topUniversities->take(10) as $index => $university)
                        <div class="flex items-center justify-between p-3 rounded-lg 
                            {{ $index === 0 ? 'bg-green-100 border border-green-300' : 
                               ($index === 1 ? 'bg-blue-100 border border-blue-300' : 
                               ($index === 2 ? 'bg-purple-100 border border-purple-300' : 'bg-gray-50')) }}">
                            <div class="flex items-center">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                                    {{ $index === 0 ? 'bg-green-500 text-white' : 
                                       ($index === 1 ? 'bg-blue-500 text-white' : 
                                       ($index === 2 ? 'bg-purple-500 text-white' : 'bg-gray-500 text-white')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <div class="ml-3">
                                    <p class="font-semibold text-gray-800">{{ $university->name }}</p>
                                    <p class="text-sm text-gray-600">University Ranking</p>
                                </div>
                            </div>
                            <span class="font-bold text-lg text-green-600">{{ $university->total_score ?? 0 }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="text-center mt-12 text-gray-600">
            <p>&copy; 2024 University Competition Platform. All rights reserved.</p>
        </div>
    </div>
</body>
</html>