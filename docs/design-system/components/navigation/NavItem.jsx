import React from 'react';

export function NavItem({ icon, label, active, onClick, badge }) {
  return (
    <button onClick={onClick} style={{
      display: 'flex', alignItems: 'center', gap: 14, width: '100%', padding: '14px 18px',
      border: 'none', borderRadius: 'var(--radius-md)', cursor: 'pointer', textAlign: 'left',
      background: active ? 'var(--primary-50)' : 'transparent', color: active ? 'var(--primary-700)' : 'var(--n-700)',
      fontFamily: 'var(--font-sans)', fontSize: 'var(--text-base)', fontWeight: active ? 'var(--weight-semibold)' : 'var(--weight-medium)',
    }}>
      <span aria-hidden="true" style={{ fontSize: 22, width: 28, textAlign: 'center' }}>{icon}</span>
      <span style={{ flex: 1 }}>{label}</span>
      {badge && <span style={{ background: 'var(--danger-500)', color: '#fff', fontSize: 11, fontWeight: 700, borderRadius: 'var(--radius-full)', padding: '2px 8px' }}>{badge}</span>}
    </button>
  );
}
