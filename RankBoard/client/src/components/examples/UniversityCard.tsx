import UniversityCard from '../UniversityCard'

export default function UniversityCardExample() {
  const mockUniversity = {
    rank: 1,
    name: "Massachusetts Institute of Technology",
    totalScore: 45280
  };

  return (
    <div className="p-8 bg-background max-w-md">
      <UniversityCard university={mockUniversity} />
    </div>
  )
}
