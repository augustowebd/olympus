import React from 'react';

export function Checkbox({ label, checked, onChange }) {
  return (
    <label style={{ display: 'inline-flex', alignItems: 'center', gap: 10, fontFamily: 'var(--font-sans)', cursor: 'pointer', minHeight: '44px' }}>
      <input type="checkbox" checked={checked} onChange={onChange} style={{ width: 22, height: 22, accentColor: 'var(--primary-600)' }} />
      <span style={{ fontSize: 'var(--text-base)', color: 'var(--text-primary)' }}>{label}</span>
    </label>
  );
}
