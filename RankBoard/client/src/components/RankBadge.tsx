import { Medal } from "lucide-react";

interface RankBadgeProps {
  rank: number;
}

export default function RankBadge({ rank }: RankBadgeProps) {
  const isPodium = rank <= 3;
  
  const getBadgeStyles = () => {
    switch (rank) {
      case 1:
        return "bg-gradient-to-br from-gold to-yellow-600 text-white shadow-lg";
      case 2:
        return "bg-gradient-to-br from-silver to-gray-400 text-gray-800 shadow-md";
      case 3:
        return "bg-gradient-to-br from-bronze to-orange-700 text-white shadow-md";
      default:
        return "bg-muted text-muted-foreground border border-border";
    }
  };

  return (
    <div
      className={`flex items-center justify-center rounded-full transition-transform hover:scale-110 ${getBadgeStyles()}`}
      style={{
        width: rank <= 3 ? "32px" : "28px",
        height: rank <= 3 ? "32px" : "28px",
        minWidth: rank <= 3 ? "32px" : "28px",
      }}
      data-testid={`rank-badge-${rank}`}
    >
      {isPodium ? (
        <Medal className="w-4 h-4" />
      ) : (
        <span className="text-xs font-black tabular-nums">{rank}</span>
      )}
    </div>
  );
}
