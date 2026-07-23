---
name: granja-erp-design
description: Use this skill to generate well-branded interfaces and screens for the Granja ERP (egg-laying farm management system) — for production or throwaway prototypes/mocks. Contains design tokens, colors, type, icons, and UI component conventions plus the established CRUD/screen patterns for this system.
user-invocable: true
---

Read `readme.md` in this skill for the full design guide (visual foundations, content tone, iconography) and explore `components/`, `tokens/`, `ui_kits/`.

If the user invokes this skill without other guidance, ask what module/screen they want to build (see "Módulos do sistema" in readme.md for the full inventory — most are unbuilt beyond the sidebar), then build it following the patterns below **exactly** — this system has an established look and interaction language; do not improvise new patterns.

## Screen pattern — CRUD modules (Lotes, Equipes, etc.)

Every "cadastro"/registro module follows this exact shape, in this order:

1. **Grid first.** The module's default view is always a list: title + primary "+ Novo <item>" button top-right.
2. **Search + filters bar** directly below the header, in its own card: a search Input (flex 1) + 1–3 filter Selects + a "Limpar filtros" ghost button. Never skip this even for small datasets.
3. **Table** below, with a **centered "Ação" column** as the last column containing small (26px) icon-only buttons in this fixed order: `eye` (Detalhar), `edit` (Alterar), `power` (Desativar), `trash` (Excluir) — colors: secondary/primary-600/warning-700/danger-500 respectively. Table rows alternate `var(--bg-surface)` / `var(--bg-page)`, compact padding (~9px vertical).
4. **"+ Novo <item>" REPLACES the grid with an inline two-column form** (never a modal/Dialog as the primary create flow) — same screen, same padding, header becomes the form title + "Cancelar"/"Salvar" buttons top-right, "* Campos obrigatórios" legend under the title. Two side-by-side cards (e.g. "Identificação" / "Plantel") each with an uppercase small-caps section label, grouping related fields.
5. **"Detalhar" (eye icon) replaces the grid with the SAME two-column layout in read-only mode**: every Input/Select gets `disabled`, title becomes "Detalhes do <item>" with a "Modo somente leitura" subtitle, actions are "Voltar" + "Editar".
6. Dialog (modal) is reserved for **confirmations only** (e.g. delete confirmation) — never for primary data entry.
7. On save, show a bottom-right `Toast` (tone success, auto-dismiss ~2.6s) confirming the action; never a silent save.
8. A persistent `Sidebar` (via the `AppShell` shell pattern) wraps every authenticated screen — never add a "Voltar ao painel" link; navigate via sidebar clicks only.

## Component & token conventions (do not deviate)

- **Palette**: terracotta primary (`--primary-*`, oklch hue ~45), green accent (`--accent-*`, hue ~150) for positive/production indicators, warm neutrals (hue ~70). Semantic warning (amber)/danger (red) per tokens.css.
- **Type**: Inter only, via `tokens/typography.css`.
- **Icons**: use the `Icon` component (`components/icons/Icon.jsx`) exclusively — a hand-built monochrome line-icon set (stroke, currentColor). **Never use emoji for UI icons.** Add new icons to this one component (simple stroke shapes only: rect/circle/line/simple path) rather than inventing a new icon mechanism.
- **Required fields**: `<Input required>` / `<Select required>` — red asterisk after label, plus a "* Campos obrigatórios" legend once per form.
- **Read-only fields**: `<Input disabled>` / `<Select disabled>` — sunken background, muted text. Used only in Detalhar views.
- **Dates**: `<Input type="date">` — auto-masks free typing to `dd/mm/aaaa` (never a native browser date picker, never mm/dd/yyyy).
- **Currency**: `<Input type="currency">` — auto-masks to pt-BR (`R$ 0.000,00`), prefix rendered outside the input.
- **Tables**: `<Table columns={[{key,label,align}]} rows={[...]} />` — pass `align:'center'` on action columns.
- **Charts**: build with plain divs (bar) or inline SVG `polyline`/`circle` (line) using palette tokens for series colors — never a charting library, never `React.createElement` outside a template. Always include a color-swatch legend. Line charts showing day-over-day trends should annotate each point with the signed delta (green up / red down).
- **Alerts/status lists**: categorize into **Aviso** (info, primary tone, `info` icon) / **Atenção** (warning tone, `alert` icon) / **Crítico** (danger tone, `alert` icon) — never a flat, uncategorized badge list.
- **Selects**: neutral disabled placeholder option is always literally "Selecione" (component default) — never a category name like "Cargo" as the placeholder; give the field a `label` instead.
- **Tap targets**: 56px min height on Button/Input/Select — this is a field/tablet-first ERP, not a dense desktop app.

## Files

- `styles.css` (+ `tokens/`) — load first, always.
- `components/` — `forms/` (Button, Input, Select, Checkbox, Switch, DatePicker), `feedback/` (Badge, Toast, Progress), `navigation/` (Sidebar, NavItem, Tabs), `data/` (StatCard, Table), `overlay/` (Dialog, Modal), `icons/` (Icon).
- `ui_kits/granja-erp/` — reference implementation: `LoginScreen`, `DashboardScreen`, `RegistroScreen` (Lotes CRUD), `EquipesScreen` (RH CRUD), `RelatoriosScreen`. **Copy the patterns in `RegistroScreen.jsx` and `EquipesScreen.jsx` as the template for any new CRUD module** (Manejo, Alimentação, Estoque, Compras, Comercial, Financeiro, Patrimônio) — same grid → form → detail flow, same StatCard row, same Sidebar wiring in the shell.

If building a new module screen, add its nav item wiring to the `AppShell`/`App` switch in `ui_kits/granja-erp/index.html` the same way `producao`/`rh`/`relatorios` are wired.
