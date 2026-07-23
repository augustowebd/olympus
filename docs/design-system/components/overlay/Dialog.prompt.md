Modal for confirmations and short forms (e.g. confirm exclusão de lote).

```jsx
<Dialog open={open} title="Excluir lote?" onClose={close} actions={<><Button variant="secondary">Cancelar</Button><Button variant="danger">Excluir</Button></>}>
  Esta ação não pode ser desfeita.
</Dialog>
```
