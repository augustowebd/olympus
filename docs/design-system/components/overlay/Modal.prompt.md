Overlay com backdrop escurecido — mesmo componente visual do Dialog, com wrapper de tela cheia. Reservado a confirmações curtas (excluir, desativar); nunca para criação/edição primária de dados (ver SKILL.md).

```jsx
<Modal open={open} title="Excluir registro?" onClose={close} actions={<><Button variant="secondary">Cancelar</Button><Button variant="danger">Excluir</Button></>}>
  Esta ação não pode ser desfeita.
</Modal>
```
