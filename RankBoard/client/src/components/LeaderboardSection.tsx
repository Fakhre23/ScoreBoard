import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { LucideIcon } from "lucide-react";

interface LeaderboardSectionProps {
  title: string;
  icon: LucideIcon;
  children: React.ReactNode;
}

export default function LeaderboardSection({
  title,
  icon: Icon,
  children,
}: LeaderboardSectionProps) {
  return (
    <Card className="border border-card-border shadow-lg" data-testid={`section-${title.toLowerCase().replace(/\s+/g, '-')}`}>
      <CardHeader className="pb-4">
        <CardTitle className="flex items-center gap-2 text-2xl font-bold text-foreground">
          <Icon className="w-6 h-6 text-primary" />
          {title}
        </CardTitle>
      </CardHeader>
      <CardContent className="space-y-2">
        {children}
      </CardContent>
    </Card>
  );
}
