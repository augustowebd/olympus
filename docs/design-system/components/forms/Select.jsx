import React from 'react';

export function Select({ label, value, onChange, options = [], placeholder = 'Selecione', required, disabled }) {
  return (
    <label style={{ display: 'flex', flexDirection: 'column', gap: 6, fontFamily: 'var(--font-sans)', width: '100%' }}>
      {label && <span style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-medium)', color: 'var(--text-secondary)' }}>{label}{required && <span style={{ color: 'var(--danger-500)' }}> *</span>}</span>}
      <select
        value={value}
        onChange={onChange}
        required={required}
        disabled={disabled}
        style={{ minHeight: 'var(--tap-target-min)', padding: '0 14px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border-default)', background: disabled ? 'var(--bg-sunken)' : 'var(--bg-surface)', fontSize: 'var(--text-base)', fontFamily: 'var(--font-sans)', color: disabled ? 'var(--text-secondary)' : 'var(--text-primary)' }}
      >
        <option value="" disabled>{placeholder}</option>
        {options.map((opt) => (
          <option key={opt.value} value={opt.value}>{opt.label}</option>
        ))}
      </select>
    </label>
  );
}
