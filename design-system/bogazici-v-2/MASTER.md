# Boğaziçi Restoran — v-2 Design System (MASTER)

> Source of truth for the **v-2** visual & interaction system. All pages under `v-2/`
> inherit from this file. Page-specific deviations live in `pages/<page-name>.md`
> and override the rules below only where explicitly noted.

---

## 1. Concept

**Editorial Coastal** — magazine-driven, typography-first, image-generous. Calm and
premium; the interface behaves like a well-set table rather than an app. Content
unfolds in *chapters* (Deniz, Sofra, Şubeler) as the reader scrolls; hero photography
runs full-bleed, headlines are the loudest visual element.

Character in one line: **sakin, sofistike, mise-en-scène — Boğaz'ın akşam tonu**.

---

## 2. Color

### 2.1 Light tokens

| Token | Hex | Purpose |
|---|---|---|
| `--primary` | `#0E1B2C` | Nav, headings, primary button surface |
| `--on-primary` | `#FAF6EF` | Text on primary |
| `--accent` | `#B8863B` | **Surface only** (button fill, block bg) |
| `--accent-strong` | `#8F6528` | **Text, icon, underline, thin rule** (AA-safe) |
| `--on-accent` | `#0E1B2C` | Text on accent surface |
| `--background` | `#F7F2EA` | Page ground |
| `--foreground` | `#14181F` | Body text |
| `--card` | `#FFFFFF` | Elevated surface |
| `--muted` | `#E9E1D3` | Neutral block / tablecloth tone |
| `--muted-fg` | `#5B6472` | Secondary text |
| `--border` | `#D9CFBD` | Decorative card edge (non-interactive) |
| `--border-input` | `#8B8578` | Form input / interactive boundary (≥3:1) |
| `--destructive` | `#B4322A` | Error |
| `--ring` | `#0E1B2C` | Focus ring (2px width, 2px offset) |

### 2.2 Dark tokens

| Token | Hex | vs `--background` `#0B1220` |
|---|---|---|
| `--background` | `#0B1220` | — |
| `--card` | `#121B2A` | — |
| `--foreground` | `#F0EADC` | 15.61:1 AAA |
| `--accent` | `#D5A25A` | 8.15:1 (safe for surface **and** text/icon in dark) |
| `--on-accent` | `#0B1220` | high contrast on `--accent` |
| `--border` | `#22304A` | decorative only |
| `--border-input` | `#5A6A85` | ≥3:1 non-text |

### 2.3 WCAG contrast — verified pairs (light)

| Pair | Ratio | Grade | Use |
|---|---|---|---|
| `--on-primary` / `--primary` | 16.09:1 | AAA | primary button text |
| `--foreground` / `--background` | 15.97:1 | AAA | body |
| `--foreground` / `--card` | 17.79:1 | AAA | body on card |
| `--primary` / `--background` | 15.55:1 | AAA | headline |
| `--muted-fg` / `--background` | 5.37:1 | AA | meta text |
| `--muted-fg` / `--card` | 5.98:1 | AA | meta on card |
| `--on-accent` / `--accent` | 5.37:1 | AA | button text on brass fill |
| **`--accent` / `--background`** | **2.89:1** | **FAIL** | **never for text/icon** |
| **`--accent-strong` / `--background`** | **4.64:1** | **AA** | link, icon, underline |
| `--accent-strong` / `--card` | 5.17:1 | AA | link on card |
| `--destructive` / `--background` | 5.49:1 | AA | error text |
| `--border-input` / `--background` | 3.01:1 | ≥3:1 non-text | input boundary |
| `--border` / `--background` | 1.38:1 | decorative-only | never for inputs / stateful boundary |

**Non-negotiable rule:** `--accent (#B8863B)` is a **surface** color. Every mark that
carries information (text, glyph, underline, thin rule, chart series line) uses
`--accent-strong (#8F6528)` in light mode, or `--accent (#D5A25A)` in dark mode.

---

## 3. Typography — Magazine Stack

- **Display / H1–H2:** `Playfair Display` (400, 600, 700). High-contrast serif; handles
  Turkish diacritics cleanly.
- **Body / UI:** `Inter` (400, 500, 600). Safe in forms, tables, navigation.
- **Label / small-caps:** `Inter` 500, `text-transform: uppercase`, `letter-spacing: 0.14em`.

### 3.1 Scale (rem, base 16)

| Token | px | Use |
|---|---|---|
| `--fs-xs` | 12 | micro-labels, disclaimers |
| `--fs-sm` | 14 | secondary UI |
| `--fs-base` | 16 | body |
| `--fs-md` | 18 | lead paragraph |
| `--fs-lg` | 22 | section intro |
| `--fs-xl` | 28 | H3 |
| `--fs-2xl` | 40 | H2 |
| `--fs-3xl` | 56 | H1 (tablet) |
| `--fs-4xl` | 80 | H1 (desktop hero) |

Mobile H1: `44px`. Line-height: body `1.65`, headings `1.1`. Long-form paragraph max
measure: 65ch.

### 3.2 CSS import

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
```

---

## 4. Space, Radius, Elevation

### 4.1 Spacing scale (8pt base)

`4 · 8 · 12 · 16 · 24 · 32 · 48 · 64 · 96 · 128` (px)

Density is **standard/spacious** (4/10). Component padding and section rhythm follow
this scale — no arbitrary values.

### 4.2 Radius — one disciplined ladder

```
--radius-sm:  2px   /* badge, tag */
--radius-md:  4px   /* button, input, card, modal, hero block */
--radius-full: 50%  /* avatar / profile only */
```

**No pill / 999px anywhere.** Buttons share the card radius so the whole system
reads as a single editorial surface.

### 4.3 Elevation

Shadows are near-absent. Two levels only:

- `--elev-1`: `0 1px 0 var(--border)` — cards, dividers
- `--elev-2`: `0 24px 60px -30px rgba(14,27,44,.25)` — sticky menu, modal, dropdown

No glassmorphism, no gradient overlays, no colored shadows.

---

## 5. Motion — GSAP + ScrollTrigger, disciplined

### 5.1 Tier: 5/10 (standard). Global tokens

- Micro (hover, focus): `150–200ms`, `ease-out`
- Component reveal (fade + 16–24px translate): `400–500ms`, `power2.out`
- Chapter scrub (desktop only): mapped to scroll progress via `ScrollTrigger`
- Stagger for grids: `60ms` per item, `back.out(1.4)`
- Sticky nav shrink: `220ms`, `ease-out`
- Exit ≈ 70% of enter duration
- All motion respects `prefers-reduced-motion: reduce` (final state, no animation)

### 5.2 What belongs in **CSS only** (do not load GSAP for these)

| Interaction | Technique |
|---|---|
| Button hover / press | `transition: background/transform 200ms ease-out` |
| Link underline grow | `::after` + `transform: scaleX()` |
| Card border → accent on hover | `transition: border-color 200ms` |
| Focus ring | `:focus-visible { outline: 2px solid var(--ring); outline-offset: 2px }` |
| Nav shrink on scroll | `position: sticky` + class toggle + CSS `transition` |
| Overlay / mobile menu | `transform: translateY()` + `opacity` transition |
| Image hover `scale(1.02)` | `transition: transform 300ms` |
| Skeleton shimmer | CSS `@keyframes` |

### 5.3 What **requires GSAP + ScrollTrigger**

| Interaction | Why GSAP |
|---|---|
| Chapter transitions with scroll-scrub | Position-linked timing |
| Hero parallax / pinned hero | `ScrollTrigger.pin` |
| Menu-page split-text headline reveal | `SplitText` + stagger |
| Gallery masonry stagger reveal | Grid-aware stagger (`grid: 'auto'`) |
| Reservation SVG breathing hint (first 3s) | Timeline + repeat, then `kill()` |
| Şubeler: list ↔ map fly-to sync | Timeline synced with map SDK |

### 5.4 Mobile / reduced-motion strategy

Single entry point in the app shell:

```js
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
gsap.registerPlugin(ScrollTrigger);

ScrollTrigger.matchMedia({
  // Desktop + tablet, full motion allowed
  "(min-width: 768px) and (prefers-reduced-motion: no-preference)": () => {
    // pin, scrub, parallax, split-text register here
  },

  // Mobile — no pin, no scrub, no parallax; one-shot reveals only
  "(max-width: 767px) and (prefers-reduced-motion: no-preference)": () => {
    gsap.utils.toArray('[data-reveal]').forEach((el) =>
      gsap.from(el, {
        opacity: 0, y: 16, duration: 0.5, ease: 'power2.out',
        scrollTrigger: { trigger: el, start: 'top 85%', once: true },
      })
    );
  },

  // Reduced motion — no animation, final state
  "(prefers-reduced-motion: reduce)": () => {},
});
```

Additional rules:

- `will-change` is added only for the duration of an animation, then removed.
- GSAP bundle is route-level lazy-loaded; per-page dynamic import outside the home page.
- SSR / no-JS: `[data-reveal]` content ships **visible** (`opacity: 1`); JS then adds a
  class that resets to hidden and starts the animation, so JS-off users see full content.

---

## 6. Layout & Grid

- Grid: 12-column, `gap: 24px` desktop / `16px` tablet / `16px` mobile.
- Container max-width: `1280px`; horizontal gutters `clamp(16px, 4vw, 48px)`.
- Breakpoints: `sm 640 · md 768 · lg 1024 · xl 1280 · 2xl 1536`.
- Mobile-first. No horizontal scroll on any viewport ≥ 320px.
- Sticky nav offset reserved via `scroll-margin-top: 96px` on section anchors.

---

## 7. Page patterns

| Page | Pattern | Key detail |
|---|---|---|
| Anasayfa | Full-bleed hero → chapters → CTA | Playfair 80/44; video/photo hero (poster fallback) |
| Kurumsal | Split editorial (text + portrait) | Pull-quote in Playfair italic 40/28 |
| Şubeler | 3-up branch cards + shared map region | Per branch: cover, hours, phone, "Yol tarifi" + "Rezervasyon" |
| Hizmetler | Icon + short-text ribbon | Catering, kurumsal davet, özel menü, düğün |
| Menü | Editorial two-column list | Dikey chapter'lar; fiyat sağda `font-variant-numeric: tabular-nums` |
| Galeri | Masonry + lightbox | Kategori: Yemekler / Mekân / Etkinlik |
| **Rezervasyon** | **Zone-select via SVG floor plan + form** | See §7.1 |
| İletişim | Full-bleed map + form below | Per-branch card with phone, address, hours |

### 7.1 Rezervasyon layout (bölge seçimli)

```
┌──────────────────────────────────────────────────────────────┐
│  Branch segmented control: Bebek · Sarıyer · Beykoz          │
├────────────────────────────────┬─────────────────────────────┤
│                                │  Rezervasyon Detayı         │
│   SVG FLOOR PLAN               │  ─────────────────────      │
│   Zones as tabbable <path>     │  Seçili bölge:              │
│   (Teras · İç Salon ·          │   › Teras – Deniz manzara   │
│   Bahçe · Deniz Manzara)       │                             │
│                                │  Tarih          Kişi        │
│   hover: outline + label       │  [__/__/____]   [ − 4 + ]   │
│   selected: accent fill + tint │                             │
│                                │  Saat (chip radiogroup)     │
│   Legend below                 │  [18:30][19:00][19:30]…     │
│                                │                             │
│                                │  Ad Soyad · Telefon · Not   │
│                                │  [ Rezervasyonu Onayla ]    │
└────────────────────────────────┴─────────────────────────────┘
```

**Responsive**
- Desktop (≥1024): 12-col grid — SVG `col-span-7`, form `col-span-5`; form is
  `position: sticky; top: 96px`.
- Tablet (768–1023): 6+6; form still sticky.
- Mobile (<768): SVG on top at `aspect-ratio: 4/3`, form below; SVG supports
  pinch-zoom + horizontal scroll; a **"Liste görünümü"** tab is required as a
  keyboard-only / screen-reader fallback — zone selection must not be gesture-only.

**SVG requirements**
- Every zone: `<path role="button" tabindex="0" aria-label="Teras – Deniz manzara, 8 masa müsait">`.
- Keyboard: `Enter` / `Space` selects; arrow keys move between zones (roving tabindex).
- Never rely on color alone — include a visible label and an icon per zone;
  `aria-pressed="true"` when selected.
- `pointer-events` only on `<path>` elements; empty space does not deselect.
- Focus indicator: `2px --ring` + `2px` offset; hover ≠ focus.
- `prefers-reduced-motion`: no breathing hint, only static border/fill transitions.

**Form behavior**
- Tarih / saat controls are `disabled` until a zone is selected; helper text:
  "Önce bir bölge seçin".
- On selection, an `aria-live="polite"` region announces the choice and availability.
- Time chips use `role="radiogroup"`; arrow keys move focus.
- Guest count: numeric stepper with `<input type="number" inputmode="numeric">`,
  min 1 / max 12.
- Inline validation on blur; error under the field with `aria-describedby`; failed
  multi-field submit focuses a linked error summary at the form top.

---

## 8. Component principles

### 8.1 Buttons

- **Primary:** solid `--primary` fill, `--on-primary` text, `4px` radius, `16px 24px`
  padding, `--fs-base`.
- **Secondary:** transparent fill, `1px --primary` border, `--primary` text.
- **Tertiary / link:** text-only in `--accent-strong` with animated underline
  (`::after` scaleX). Never uses `--accent` for the glyph.
- **Danger:** solid `--destructive`, `--on-destructive` text.
- Disabled: opacity 0.5, `cursor: not-allowed`, `aria-disabled="true"`.
- Loading: keep width, swap label for spinner, `aria-busy="true"`.

### 8.2 Navigation

- Top utility strip: phone, language switcher (small caps).
- Main nav below: brand mark left, links center, "Rezervasyon" primary button right.
- Sticky; shrinks from `88px` to `64px` on scroll (CSS transition).
- Mobile: hamburger opens full-screen overlay menu; close on route change.
- Current route: `--accent-strong` underline + `aria-current="page"`.

### 8.3 Forms

- Label above input (never placeholder-only).
- Border: `--border-input` (3:1). Focus: `2px --ring` outline + `outline-offset: 2px`.
- Helper text persistent below; error replaces helper, keeps space to prevent CLS.
- `autocomplete` and `inputmode` set for every field where meaningful.

### 8.4 Cards (branch / menu)

- `--card` bg, `1px --border`, no shadow, `4px` radius.
- Hover: border → `--accent-strong`, 200ms.
- Image at top with `aspect-ratio: 4/3`, `object-fit: cover`.

### 8.5 Icons

- Phosphor `regular` weight, `24px` default (`16px` inline in dense meta).
- Single stroke width across the system.
- Decorative icons (next to a visible label): `aria-hidden="true"`.
- Icon-only controls: `aria-label` required.
- **No emoji anywhere.**

---

## 9. Accessibility floor

- WCAG **2.2 AA** minimum.
- Every focusable element has a visible `:focus-visible` state ≥ 3:1 contrast.
- Zone SVG has a Liste fallback (no gesture-only interaction).
- All motion respects `prefers-reduced-motion`.
- Font sizing scales with browser zoom / OS text size; no `overflow: hidden` traps
  on containers holding long strings.
- Color is never the sole carrier of meaning (state also uses icon + text).
- Skip-to-content link is the first focusable element.

---

## 10. Anti-patterns (do not ship)

- Pill / 999px radius anywhere in v-2.
- Using `--accent (#B8863B)` for text, icons, links, or thin rules.
- Placeholder-only form labels.
- Emoji used as UI icons.
- Autoplaying hero video with sound.
- Glassmorphism, colored drop-shadows, gradient overlays over food photography.
- ScrollTrigger `pin` / `scrub` / parallax on mobile viewports.
- Hover-only affordances for interactive elements (must also work on tap and via keyboard).

---

## 11. Pre-delivery checklist

- [ ] Contrast pairs verified against §2.3
- [ ] No `--accent` used for text/icon in light mode
- [ ] All buttons 4px radius (no pills)
- [ ] Reservation zone SVG has keyboard + list fallback
- [ ] GSAP loaded only on routes that need it; CSS interactions do not import GSAP
- [ ] `ScrollTrigger.matchMedia` gates pin/scrub to `(min-width: 768px)`
- [ ] `prefers-reduced-motion` renders final state, no animation
- [ ] Verified at 375, 768, 1024, 1440 widths, portrait + landscape
- [ ] Dark mode contrast checked independently
- [ ] All icons SVG (Phosphor regular), no emoji
- [ ] Focus-visible outline on every interactive element
