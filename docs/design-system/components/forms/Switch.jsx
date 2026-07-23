import React from 'react';

export function Switch({ label, checked, onChange }) {
  return (
    <label style={{ display: 'inline-flex', alignItems: 'center', gap: 10, fontFamily: 'var(--font-sans)', cursor: 'pointer' }}>
      <span
        onClick={() => onChange && onChange(!checked)}
        style={{ width: 44, height: 26, borderRadius: 'var(--radius-full)', background: checked ? 'var(--primary-600)' : 'var(--n-300)', position: 'relative', transition: 'background var(--duration-base) var(--ease-standard)' }}
      >
        <span style={{ position: 'absolute', top: 3, left: checked ? 21 : 3, width: 20, height: 20, borderRadius: '50%', background: 'var(--bg-surface)', boxShadow: 'var(--shadow-sm)', transition: 'left var(--duration-base) var(--ease-standard)' }} />
      </span>
      {label && <span style={{ fontSize: 'var(--text-base)', color: 'var(--text-primary)' }}>{label}</span>}
    </label>
  );
}
