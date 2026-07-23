Primary app navigation — a left rail with large icon + label rows (44px+ tap target), one active state. Used on every authenticated screen.

```jsx
<Sidebar farmName="Granja Santa Fé" activeId="dashboard" onSelect={setPage}
  items={[{id:'dashboard', icon:'📊', label:'Painel'}, {id:'producao', icon:'🥚', label:'Produção'}]} />
```
