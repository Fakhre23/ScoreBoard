import { Trophy, Users, GraduationCap, Loader2, ArrowLeft, LogIn, UserPlus } from "lucide-react";
import LeaderboardSection from "@/components/LeaderboardSection";
import StudentCard from "@/components/StudentCard";
import UniversityCard from "@/components/UniversityCard";
import ThemeToggle from "@/components/ThemeToggle";
import { Button } from "@/components/ui/button";
import { useQuery } from "@tanstack/react-query";
import type { LeaderboardResponse, AuthCheckResponse } from "@shared/schema";
import { getApiUrl, getPageUrl, config } from "@/config";

export default function Leaderboard() {
  const { data, isLoading, error } = useQuery<LeaderboardResponse>({
    queryKey: [getApiUrl(config.endpoints.leaderboard)],
  });

  const { data: authData } = useQuery<AuthCheckResponse>({
    queryKey: [getApiUrl(config.endpoints.authCheck)],
    retry: false,
  });

  const isAuthenticated = authData?.authenticated ?? false;

  const handleBack = () => {
    window.history.back();
  };

  return (
    <div className="min-h-screen bg-background">
      {/* Header */}
      <header className="border-b border-border bg-card/50 backdrop-blur-sm sticky top-0 z-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
          <div className="flex items-center justify-between flex-wrap gap-3">
            <div className="flex items-center gap-3">
              <div className="p-2 bg-gradient-to-br from-primary/20 to-primary/10 rounded-lg">
                <Trophy className="w-6 h-6 text-primary" />
              </div>
              <h1 className="text-2xl sm:text-3xl font-black text-foreground font-display tracking-tight">
                Leaderboard
              </h1>
            </div>
            
            <div className="flex items-center gap-2">
              {isAuthenticated ? (
                <Button
                  variant="ghost"
                  onClick={handleBack}
                  data-testid="button-back"
                >
                  <ArrowLeft className="w-4 h-4 mr-2" />
                  Back
                </Button>
              ) : (
                <>
                  <Button
                    variant="ghost"
                    asChild
                    data-testid="button-login"
                  >
                    <a href={getPageUrl(config.pages.login)}>
                      <LogIn className="w-4 h-4 mr-2" />
                      Login
                    </a>
                  </Button>
                  <Button
                    variant="default"
                    asChild
                    data-testid="button-register"
                  >
                    <a href={getPageUrl(config.pages.register)}>
                      <UserPlus className="w-4 h-4 mr-2" />
                      Register
                    </a>
                  </Button>
                </>
              )}
              <ThemeToggle />
            </div>
          </div>
          <p className="text-sm text-muted-foreground mt-2">
            Top performing students and universities ranked by achievement
          </p>
        </div>
      </header>

      {/* Main Content */}
      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        {isLoading && (
          <div className="flex items-center justify-center py-20" data-testid="loading-state">
            <Loader2 className="w-8 h-8 animate-spin text-primary" />
          </div>
        )}

        {error && (
          <div className="text-center py-20" data-testid="error-state">
            <p className="text-destructive font-medium">Failed to load leaderboard data</p>
            <p className="text-sm text-muted-foreground mt-2">
              Please check your API connection
            </p>
          </div>
        )}

        {data && (
          <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            {/* Students Leaderboard */}
            <LeaderboardSection title="Top Students" icon={Users}>
              {data.users.length === 0 ? (
                <p className="text-center py-8 text-muted-foreground" data-testid="empty-students">
                  No student data available
                </p>
              ) : (
                <div className="space-y-2">
                  {data.users.map((student) => (
                    <StudentCard key={student.rank} student={student} />
                  ))}
                </div>
              )}
            </LeaderboardSection>

            {/* Universities Leaderboard */}
            <LeaderboardSection title="Top Universities" icon={GraduationCap}>
              {data.universities.length === 0 ? (
                <p className="text-center py-8 text-muted-foreground" data-testid="empty-universities">
                  No university data available
                </p>
              ) : (
                <div className="space-y-2">
                  {data.universities.map((university) => (
                    <UniversityCard key={university.rank} university={university} />
                  ))}
                </div>
              )}
            </LeaderboardSection>
          </div>
        )}
      </main>
    </div>
  );
}
