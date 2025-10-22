import LeaderboardSection from '../LeaderboardSection'
import StudentCard from '../StudentCard'
import { Users } from 'lucide-react'

export default function LeaderboardSectionExample() {
  const mockStudents = [
    {
      rank: 1,
      name: "Sarah Johnson",
      university: "MIT",
      score: 9850,
      avatar: "https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah"
    },
    {
      rank: 2,
      name: "Michael Chen",
      university: "Stanford",
      score: 9720,
      avatar: "https://api.dicebear.com/7.x/avataaars/svg?seed=Michael"
    }
  ];

  return (
    <div className="p-8 bg-background max-w-2xl">
      <LeaderboardSection title="Top Students" icon={Users}>
        {mockStudents.map((student) => (
          <StudentCard key={student.rank} student={student} />
        ))}
      </LeaderboardSection>
    </div>
  )
}
