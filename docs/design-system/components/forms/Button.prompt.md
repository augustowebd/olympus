Primary action button. Use `primary` for the single main action on a screen, `secondary` for alternatives, `ghost` for low-emphasis/text actions, `danger` for destructive actions.

```jsx
<Button variant="primary" onClick={save}>Salvar lote</Button>
<Button variant="secondary">Cancelar</Button>
```

Default size is a 56px tap target — do not shrink below `sm` (40px) for touch/tablet contexts common in this ERP.
