import RankBadge from '../RankBadge'

export default function RankBadgeExample() {
  return (
    <div className="flex gap-4 p-8 bg-background">
      <RankBadge rank={1} />
      <RankBadge rank={2} />
      <RankBadge rank={3} />
      <RankBadge rank={4} />
      <RankBadge rank={10} />
    </div>
  )
}
