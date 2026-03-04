import StudentCard from '../StudentCard'

export default function StudentCardExample() {
  const mockStudent = {
    rank: 1,
    name: "Sarah Johnson",
    university: "MIT",
    score: 9850,
    avatar: "https://api.dicebear.com/7.x/avataaars/svg?seed=Sarah"
  };

  return (
    <div className="p-8 bg-background max-w-md">
      <StudentCard student={mockStudent} />
    </div>
  )
}
