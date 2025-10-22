import { Avatar, AvatarFallback, AvatarImage } from "@/components/ui/avatar";
import RankBadge from "./RankBadge";

export interface StudentData {
  rank: number;
  name: string;
  university: string;
  score: number;
  avatar?: string;
}

interface StudentCardProps {
  student: StudentData;
}

export default function StudentCard({ student }: StudentCardProps) {
  const { rank, name, university, score, avatar } = student;
  const isPodium = rank <= 3;
  
  const getInitials = (name: string) => {
    return name
      .split(" ")
      .map((n) => n[0])
      .join("")
      .toUpperCase()
      .slice(0, 2);
  };

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
      className={`flex items-center gap-3 p-4 rounded-lg transition-all duration-200 hover:scale-[1.02] hover-elevate ${
        isPodium ? getPodiumBg() : ""
      }`}
      data-testid={`student-card-${rank}`}
    >
      <RankBadge rank={rank} />
      
      <Avatar className="h-12 w-12 border-2 border-border shadow-sm">
        <AvatarImage src={avatar} alt={name} />
        <AvatarFallback className="bg-gradient-to-br from-primary/20 to-primary/10 text-foreground font-semibold">
          {getInitials(name)}
        </AvatarFallback>
      </Avatar>

      <div className="flex-1 min-w-0">
        <h3 className="font-semibold text-base text-foreground truncate" data-testid={`text-student-name-${rank}`}>
          {name}
        </h3>
        <p className="text-sm text-muted-foreground truncate" data-testid={`text-university-${rank}`}>
          {university}
        </p>
      </div>

      <div className="text-right">
        <p className="text-xl font-black text-success tabular-nums" data-testid={`text-score-${rank}`}>
          {score.toLocaleString()}
        </p>
      </div>
    </div>
  );
}
