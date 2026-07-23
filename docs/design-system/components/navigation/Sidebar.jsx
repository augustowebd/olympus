import React from 'react';
import { NavItem } from './NavItem.jsx';

export function Sidebar({ items, activeId, onSelect, farmName }) {
  return (
    <nav style={{ width: 260, background: 'var(--bg-surface)', borderRight: '1px solid var(--border-subtle)', height: '100%', display: 'flex', flexDirection: 'column', padding: 'var(--space-4)', gap: 4, boxSizing: 'border-box' }}>
      <div style={{ fontFamily: 'var(--font-sans)', fontWeight: 'var(--weight-extrabold)', fontSize: 'var(--text-md)', color: 'var(--primary-700)', padding: '10px 12px 20px' }}>{farmName || 'Granja ERP'}</div>
      {items.map((it) => (
        <NavItem key={it.id} icon={it.icon} label={it.label} badge={it.badge} active={it.id === activeId} onClick={() => onSelect && onSelect(it.id)} />
      ))}
    </nav>
  );
}
