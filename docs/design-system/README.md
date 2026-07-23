# Handoff: Granja ERP — Design System & Screens

## Overview
ERP para gestão de granjas de postura (produção de ovos), cobrindo produção, manejo animal, alimentação, estoque, compras, comercial, financeiro, patrimônio e RH. Público interno, baixa familiaridade com tecnologia — prioriza ícones grandes, poucas opções por tela, alvo de toque generoso (56px mín).

## About the Design Files
The files in this bundle are **design references created in HTML** (React-via-Babel prototypes) — they show the intended look, component behavior, and screen flows, not production code to copy directly. The task is to **recreate these designs in the target codebase's real environment** (whatever stack the ERP will run on — React/Next, Vue, mobile native, etc.), using its established patterns, using the tokens and component contracts documented below as the source of truth for values.

## Fidelity
**High-fidelity.** Colors, typography, spacing, and interaction patterns are final. Recreate pixel-close using the target codebase's component library, driven by the token values in `tokens/`.

## Screens / Views

### 1. Login
- Centered card (max-width ~420px) on `--bg-page`, farm name wordmark in `--primary-700`.
- Fields: usuário/e-mail (`Input`), senha (`Input` type password), "Entrar" primary `Button` full-width.
- File: `ui_kits/granja-erp/LoginScreen.jsx`.

### 2. Painel (Dashboard)
- Persistent `Sidebar` (260px) + main content area.
- Top row: `StatCard` grid — produção do dia, % postura, consumo de ração, mortalidade, estoque crítico, pedidos pendentes, faturamento.
- "Produção por galpão — última semana": SVG line chart (`LineChart`), one series per galpão, color-coded legend, day-over-day delta labels above each point (green = up, red = down) — data Seg–Dom.
- "Alertas" panel: categorized list — **Aviso** (info icon, `--primary-*` tone), **Atenção** (`alert` icon, `--warning-*` tone), **Crítico** (`alert` icon, `--danger-*` tone). Never a flat/uncategorized badge list.
- File: `ui_kits/granja-erp/DashboardScreen.jsx`.

### 3. Lotes (Registro) — reference CRUD module
### 4. Equipes — reference CRUD module
Both follow the **same fixed pattern** (this is the template for every other module: Manejo, Alimentação, Estoque, Compras, Comercial, Financeiro, Patrimônio):
1. **Grid (list) view** — title + "+ Novo <item>" button top-right.
2. **Search + filters bar** in its own card directly below header: search `Input` (flex 1) + 1–3 filter `Select`s + "Limpar filtros" ghost button.
3. **Table**: alternating row backgrounds (`--bg-surface` / `--bg-page`), compact ~9px vertical padding, centered **"Ação"** column with 26px icon-only buttons in fixed order: `eye` (Detalhar, `--text-secondary`), `edit` (Alterar, `--primary-600`), `power` (Desativar, `--warning-700`), `trash` (Excluir, `--danger-500`).
4. **"+ Novo <item>"** replaces the grid in place (never a modal) with a 2-column form: header becomes form title + "Cancelar"/"Salvar", "* Campos obrigatórios" legend, fields grouped into labeled cards (e.g. "Identificação" / "Plantel").
5. **"Detalhar"** (eye icon) replaces the grid with the same 2-column layout, all fields `disabled`, title "Detalhes do <item>" + "Modo somente leitura" subtitle, actions "Voltar"/"Editar".
6. `Dialog`/`Modal` (backdrop overlay) is reserved for **confirmations only** — never primary data entry.
7. Save triggers a bottom-right success `Toast`, auto-dismiss ~2.6s.
8. Sidebar never leaves the screen — no "Voltar ao painel" link anywhere.

Files: `ui_kits/granja-erp/RegistroScreen.jsx` (Lotes), `ui_kits/granja-erp/EquipesScreen.jsx`.

### 5. Relatórios
- Filter bar + `Table` report example with export action.
- File: `ui_kits/granja-erp/RelatoriosScreen.jsx`.

## Interactions & Behavior
- Sidebar nav click swaps the active screen; no page reloads.
- "+ Novo" / "Detalhar" / "Editar" swap the module's content area between grid ⇄ form ⇄ read-only detail — in place, same screen, no navigation.
- Delete/deactivate icon actions open a `Modal` confirmation before acting.
- Date fields: free-typing input auto-masks to `dd/mm/aaaa` as the user types (see `formatDatePt` in `components/_preview-kit.jsx`); never a native date input. A calendar popover (`DatePicker`) is available for visual selection.
- Currency fields: free-typing auto-masks to pt-BR (`0.000,00`, `R$` prefix shown outside the input) via `formatCurrencyPt`.
- Required fields show a red asterisk after the label; disabled/read-only fields get a `--bg-sunken` background and `--text-secondary` text.
- Select components always default to the neutral placeholder option **"Selecione"** — never a category name as placeholder (give the field a `label` instead).

## State Management
Each CRUD screen holds simple local view-state: `mode` (`'list' | 'create' | 'detail' | 'edit'`), the active record, and grid filter values. No global store implied by the prototypes — adopt the target app's existing state layer (Redux/Zustand/Pinia/etc.) for real data fetching, keeping the same view-state shape.

## Design Tokens
All values live in `tokens/*.css`, loaded via `styles.css`. Full files are included in this bundle — key values:

**Colors** (OKLCH; muted/sober palette — low chroma by design, do not re-saturate):
- Primary (terracotta): `--primary-500: oklch(53% 0.075 45)`, `--primary-600: oklch(45% 0.07 42)`, `--primary-700: oklch(36% 0.06 40)`
- Accent (production green): `--accent-500: oklch(52% 0.065 150)`, `--accent-600: oklch(45% 0.065 150)`
- Warning: `--warning-500: oklch(65% 0.09 85)` · Danger: `--danger-500: oklch(55% 0.1 25)`
- Neutrals: warm-toned scale `--n-0`…`--n-900` (see `tokens/colors.css`)
- Semantic aliases: `--bg-page`, `--bg-surface`, `--bg-sunken`, `--border-subtle`, `--border-default`, `--text-primary/secondary/muted`

**Typography**: Inter (`--font-sans`), sizes `--text-xs` (12px) → `--text-3xl` (48px), weights 400–800.

**Spacing**: `--space-1` (4px) → `--space-20` (80px). `--tap-target-min: 56px` (deliberately generous for field/tablet use).

**Radius**: `--radius-sm` 6px, `--radius-md` 10px, `--radius-lg` 16px, `--radius-full` 999px.

**Shadows**: `--shadow-sm/md/lg` (see `tokens/effects.css`).

## Assets
No brand/logo files were supplied — farm name is currently a text wordmark. Icons are a **hand-built monochrome line-icon set** (`components/icons/Icon.jsx`, stroke-based SVG, `currentColor`) — no emoji, no external icon library. Add new icons to this same component, matching its stroke style. Font is Google-hosted Inter (no official brand font provided — flag if one exists).

## Files
- `styles.css` + `tokens/` — design tokens (colors, typography, spacing, effects), load first.
- `components/` — full component source per category: `forms/` (Button, Input, Select, Checkbox, Switch, DatePicker), `feedback/` (Badge, Toast, Progress), `navigation/` (Sidebar, NavItem, Tabs), `data/` (StatCard, Table), `overlay/` (Dialog, Modal), `icons/` (Icon). Each component has a `.jsx` (source), `.d.ts` (prop types), and `.prompt.md` (usage note).
- `ui_kits/granja-erp/` — reference screens: `LoginScreen.jsx`, `DashboardScreen.jsx`, `RegistroScreen.jsx` (Lotes CRUD), `EquipesScreen.jsx` (RH CRUD), `RelatoriosScreen.jsx`, wired together in `index.html` (open directly in a browser to view/click through).
- `Componentes.dc.html` — visual catalog of every component and its variants (open in a browser).
- `SKILL.md` — the design-pattern rulebook (same content as the "Screens/Views" + conventions above, written for an AI coding agent) — read this first if continuing design work on this system.

## Not yet built
Only Login, Painel, Lotes, Equipes, and Relatórios have real screens. The remaining modules listed in the Overview (Manejo, Alimentação, Estoque, Compras, Comercial, Financeiro, Patrimônio) exist only as sidebar nav entries — build them by following the CRUD pattern above and copying `RegistroScreen.jsx`/`EquipesScreen.jsx` as your template.
