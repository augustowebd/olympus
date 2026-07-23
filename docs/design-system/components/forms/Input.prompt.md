Text field with label, helper/error text, and optional unit suffix (e.g. kg, un) — used across production and stock forms. `type="date"` masks input as dd/mm/aaaa; `type="currency"` masks as pt-BR currency (R$ 0,00).

```jsx
<Input label="Peso médio (g)" value={peso} onChange={handleChange} unit="g" />
<Input label="Data de entrada" type="date" value={data} onChange={setData} required />
<Input label="Valor da venda" type="currency" value={valor} onChange={setValor} />
```
