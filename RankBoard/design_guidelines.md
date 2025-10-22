# Leaderboard Page Design Guidelines

## Design Approach: Hybrid System with Competitive Edge

**Selected Framework:** Material Design principles with competitive gaming aesthetics
**Justification:** Leaderboards require clear hierarchical information display (Material Design's strength) combined with celebratory, achievement-focused visual treatment to drive engagement and motivation.

---

## Core Design Elements

### A. Color Palette

**Primary Colors (Dark Mode):**
- Background Base: 220 15% 12% (Deep slate)
- Card Surface: 220 14% 18% (Elevated slate)
- Card Borders: 220 10% 25% (Subtle contrast)

**Accent & Ranking Colors:**
- Gold (1st Place): 45 95% 60%
- Silver (2nd Place): 210 15% 70%
- Bronze (3rd Place): 30 70% 55%
- Primary Accent: 250 75% 65% (Vibrant purple for highlights)
- Success Green: 140 65% 55% (Score indicators)

**Text Colors:**
- Primary Text: 220 10% 95%
- Secondary Text: 220 8% 70%
- Muted Text: 220 6% 55%

---

### B. Typography

**Font Families:**
- Primary: Inter (via Google Fonts) - Clean, modern readability
- Display/Rankings: Outfit or Space Grotesk (via Google Fonts) - Bold, competitive feel

**Hierarchy:**
- Page Title: 3xl/4xl, font-bold, tracking-tight
- Section Headers: xl/2xl, font-semibold
- Student/University Names: base/lg, font-medium
- Scores: xl/2xl, font-bold, tabular-nums
- University Labels: sm, font-normal, text-muted
- Rank Numbers: 2xl/3xl, font-black

---

### C. Layout System

**Spacing Primitives:** Use Tailwind units of 2, 4, 6, 8, 12, and 16

**Desktop Layout (lg+):**
- Two-column grid: `grid grid-cols-2 gap-8`
- Container: `max-w-7xl mx-auto px-8`
- Section padding: `py-12`

**Tablet/Mobile (below lg):**
- Single column stack
- Students section first, then universities
- Container: `px-4`
- Section padding: `py-8`

**Card Structure:**
- Padding: `p-6` (desktop), `p-4` (mobile)
- Border radius: `rounded-2xl`
- Border: `border border-[color]`

---

### D. Component Library

#### 1. **Page Header**
- Centered layout with gradient text effect
- Title: "Leaderboard" with subtle icon
- Tagline below explaining rankings
- Background: Subtle radial gradient overlay

#### 2. **Student Leaderboard Card (Top 10)**
- Header with icon and "Top Students" title
- Individual student rows with:
  - Rank badge (1-3 get special metallic colors, 4-10 get numbered badges)
  - Profile photo (rounded-full, 48px desktop / 40px mobile)
  - Name (bold, larger text)
  - University name (smaller, muted)
  - Score display (bold, colored, right-aligned)
- Hover state: Subtle scale and shadow elevation
- Top 3 rows get subtle background tint matching rank color

#### 3. **University Leaderboard Card (Top 4)**
- Similar structure to students
- Rows show:
  - Rank badge
  - University logo/icon placeholder (64px, rounded square)
  - University name
  - Total score (larger, emphasized)
- Visual treatment emphasizes institutional pride

#### 4. **Rank Badges**
- Positions 1-3: Circular badges with metallic gradients (gold/silver/bronze)
- Positions 4-10: Subtle circular badges with rank number
- Size: 32px diameter (desktop), 28px (mobile)

#### 5. **Profile Components**
- Photos: 2px border, shadow-sm
- Placeholders: Gradient backgrounds with initials if no photo
- Aspect ratio: 1:1 (square)

---

### E. Visual Enhancements

**Competitive Elements:**
- Top student and university get subtle glow effect
- Medal icons for podium positions (1st, 2nd, 3rd)
- Progress bars or visual score indicators (optional accent)
- Subtle trophy icon in page header

**Interactive States:**
- Hover: `transform scale-[1.02] transition-transform duration-200`
- Card shadows: `shadow-lg` on hover, `shadow-md` default
- No complex animations - keep it performant

**Dividers:**
- Between rows: 1px divider with subtle opacity
- Use sparingly - only when helpful for scanning

---

### F. Responsive Behavior

**Desktop (lg and above):**
- Side-by-side columns
- Larger profile photos and text
- More generous spacing

**Tablet (md):**
- Consider keeping two columns if space permits
- Reduce spacing slightly

**Mobile (base to sm):**
- Stack columns vertically
- Students section appears first
- Smaller profile photos (40px)
- Compact padding (p-4 instead of p-6)
- Scores might move to right side in condensed view

---

### G. Data Display Patterns

**Score Formatting:**
- Use comma separators for thousands
- Right-align all scores for easy scanning
- Bold weight, accent color
- Tabular numbers font variant

**University Attribution:**
- Display below student name
- Smaller font size (text-sm)
- Muted color
- Truncate with ellipsis if too long on mobile

---

## Images

**Profile Photos:**
- Placeholder images for students (circular avatars)
- Use randomuser.me or generated avatars for mock data
- Fallback: Colored gradient circles with user initials

**University Logos:**
- Square format with rounded corners
- Can use placeholder shields/emblems
- Maintain consistent sizing across all entries

**No Hero Image Required** - This is a data-focused utility page where content is the hero.