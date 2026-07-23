import React from 'react';

export function Table({ columns, rows }) {
  return (
    <div style={{ border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', overflow: 'hidden', fontFamily: 'var(--font-sans)' }}>
      <div style={{ overflowX: 'auto' }}>
      <table style={{ width: '100%', borderCollapse: 'collapse' }}>
        <thead>
          <tr style={{ background: 'var(--bg-sunken)' }}>
            {columns.map((c) => (
              <th key={c.key} style={{ textAlign: c.align || 'left', padding: '10px 16px', fontSize: 'var(--text-xs)', textTransform: 'uppercase', letterSpacing: '0.04em', color: 'var(--text-secondary)', fontWeight: 'var(--weight-semibold)', whiteSpace: 'nowrap' }}>{c.label}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {rows.map((r, i) => (
            <tr key={i} style={{ borderTop: '1px solid var(--border-subtle)', background: i % 2 === 0 ? 'var(--bg-surface)' : 'var(--bg-page)' }}>
              {columns.map((c) => (
                <td key={c.key} style={{ padding: '9px 16px', fontSize: 'var(--text-base)', color: 'var(--text-primary)', whiteSpace: 'nowrap', textAlign: c.align || 'left' }}>{r[c.key]}</td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
      </div>
    </div>
  );
}
