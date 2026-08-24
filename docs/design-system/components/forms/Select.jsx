import React from 'react';

export function Select({ label, value, onChange, options = [], placeholder = 'Selecione', required, disabled }) {
  return (
    <label className="ds-campo">
      {label && <span className="ds-campo__rotulo">{label}</span>}
      <select
        className="ds-select"
        value={value}
        onChange={onChange}
        required={required}
        disabled={disabled}
        style={{ padding: '0 12px', borderRadius: 'var(--radius-sm)', border: '1px solid var(--border-default)', boxShadow: required ? 'inset 2px 0 0 var(--danger-500)' : undefined, background: disabled ? 'var(--bg-sunken)' : 'var(--bg-surface)', fontFamily: 'var(--font-sans)', color: disabled ? 'var(--text-secondary)' : 'var(--text-primary)', textTransform: 'uppercase' }}
      >
        <option value="" disabled>{placeholder}</option>
        {options.map((opt) => (
          <option key={opt.value} value={opt.value}>{opt.label}</option>
        ))}
      </select>
    </label>
  );
}
