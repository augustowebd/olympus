import React from 'react';

export function StatCard({ label, value, unit, delta, icon }) {
  const deltaColor = delta && delta.startsWith('-') ? 'var(--danger-500)' : 'var(--accent-600)';
  return (
    <div style={{ background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', boxShadow: 'var(--shadow-sm)', padding: 'var(--space-5)', display: 'flex', flexDirection: 'column', gap: 8, fontFamily: 'var(--font-sans)', minWidth: 180 }}>
      <div style={{ display: 'flex', alignItems: 'center', gap: 8, color: 'var(--text-secondary)', fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-medium)' }}>
        {icon && <span aria-hidden="true">{icon}</span>}{label}
      </div>
      <div style={{ display: 'flex', alignItems: 'baseline', gap: 6 }}>
        <span style={{ fontSize: 'var(--text-2xl)', fontWeight: 'var(--weight-extrabold)', color: 'var(--text-primary)' }}>{value}</span>
        {unit && <span style={{ fontSize: 'var(--text-sm)', color: 'var(--text-muted)' }}>{unit}</span>}
      </div>
      {delta && <span style={{ fontSize: 'var(--text-xs)', fontWeight: 'var(--weight-semibold)', color: deltaColor }}>{delta}</span>}
    </div>
  );
}
