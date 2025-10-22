import { GraduationCap } from "lucide-react";
import RankBadge from "./RankBadge";

export interface UniversityData {
  rank: number;
  name: string;
  totalScore: number;
  logo?: string;
}

interface UniversityCardProps {
  university: UniversityData;
}

export default function UniversityCard({ university }: UniversityCardProps) {
  const { rank, name, totalScore, logo } = university;
  const isPodium = rank <= 3;

  const getPodiumBg = () => {
    switch (rank) {
      case 1:
        return "bg-gold/5";
      case 2:
        return "bg-silver/5";
      case 3:
        return "bg-bronze/5";
      default:
        return "";
    }
  };

  return (
    <div
      className={`flex items-center gap-4 p-4 rounded-lg transition-all duration-200 hover:scale-[1.02] hover-elevate ${
        isPodium ? getPodiumBg() : ""
      }`}
      data-testid={`university-card-${rank}`}
    >
      <RankBadge rank={rank} />

      <div className="flex items-center justify-center w-16 h-16 rounded-md bg-gradient-to-br from-primary/10 to-primary/5 border border-border shadow-sm">
        {logo ? (
          <img src={logo} alt={name} className="w-12 h-12 object-contain" />
        ) : (
          <GraduationCap className="w-8 h-8 text-primary" />
        )}
      </div>

      <div className="flex-1 min-w-0">
        <h3 className="font-semibold text-lg text-foreground truncate" data-testid={`text-university-name-${rank}`}>
          {name}
        </h3>
        <p className="text-sm text-muted-foreground">Total Score</p>
      </div>

      <div className="text-right">
        <p className="text-2xl font-black text-primary tabular-nums" data-testid={`text-total-score-${rank}`}>
          {totalScore.toLocaleString()}
        </p>
      </div>
    </div>
  );
}
