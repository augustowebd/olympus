import React from 'react';

export function Tabs({ tabs, activeId, onChange }) {
  return (
    <div style={{ display: 'flex', gap: 4, borderBottom: '1px solid var(--border-subtle)', fontFamily: 'var(--font-sans)' }}>
      {tabs.map((t) => (
        <button key={t.id} onClick={() => onChange && onChange(t.id)} style={{
          border: 'none', background: 'none', cursor: 'pointer', padding: '14px 18px',
          fontSize: 'var(--text-base)', fontWeight: t.id === activeId ? 'var(--weight-semibold)' : 'var(--weight-medium)',
          color: t.id === activeId ? 'var(--primary-700)' : 'var(--text-secondary)',
          borderBottom: t.id === activeId ? '2px solid var(--primary-600)' : '2px solid transparent', marginBottom: -1,
        }}>{t.label}</button>
      ))}
    </div>
  );
}
