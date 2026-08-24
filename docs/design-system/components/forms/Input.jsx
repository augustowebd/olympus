import React from 'react';

function formatDatePt(raw) {
  const digits = raw.replace(/\D/g, '').slice(0, 8);
  const parts = [];
  if (digits.length > 0) parts.push(digits.slice(0, 2));
  if (digits.length > 2) parts.push(digits.slice(2, 4));
  if (digits.length > 4) parts.push(digits.slice(4, 8));
  return parts.join('/');
}

function formatCurrencyPt(raw) {
  const digits = raw.replace(/\D/g, '');
  if (!digits) return '';
  const num = parseInt(digits, 10) / 100;
  return num.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

export function Input({ label, placeholder, value, onChange, type = 'text', helperText, error, icon, unit, required, disabled }) {
  const isDate = type === 'date';
  const isCurrency = type === 'currency';

  const handleMaskedChange = (e) => {
    if (!onChange) return;
    const formatted = isDate ? formatDatePt(e.target.value) : formatCurrencyPt(e.target.value);
    onChange({ ...e, target: { ...e.target, value: formatted } });
  };

  return (
    <label className="ds-campo">
      {label && <span className="ds-campo__rotulo">{label}</span>}
      <div style={{ display: 'flex', alignItems: 'center', gap: 8, minHeight: 44, padding: '0 12px', borderRadius: 'var(--radius-sm)', border: `1px solid ${error ? 'var(--danger-500)' : 'var(--border-default)'}`, boxShadow: required ? 'inset 2px 0 0 var(--danger-500)' : undefined, background: disabled ? 'var(--bg-sunken)' : 'var(--bg-surface)' }}>
        {isCurrency && <span style={{ color: 'var(--text-muted)', fontSize: 'var(--text-base)' }}>R$</span>}
        {icon && !isCurrency && <span aria-hidden="true" style={{ color: 'var(--text-muted)' }}>{icon}</span>}
        {isDate || isCurrency ? (
          <input
            type="text"
            className="ds-input"
            inputMode={isDate ? 'numeric' : 'decimal'}
            placeholder={isDate ? 'dd/mm/aaaa' : (placeholder || '0,00')}
            value={value}
            onChange={handleMaskedChange}
            maxLength={isDate ? 10 : undefined}
            required={required}
            disabled={disabled}
            style={{ flex: 1, border: 'none', outline: 'none', fontFamily: 'var(--font-sans)', color: disabled ? 'var(--text-secondary)' : 'var(--text-primary)', background: 'transparent' }}
          />
        ) : (
          <input
            type={type}
            className="ds-input"
            placeholder={placeholder}
            value={value}
            onChange={onChange}
            required={required}
            disabled={disabled}
            style={{ flex: 1, border: 'none', outline: 'none', fontFamily: 'var(--font-sans)', color: disabled ? 'var(--text-secondary)' : 'var(--text-primary)', background: 'transparent', textTransform: type === 'password' ? undefined : 'uppercase' }}
          />
        )}
        {unit && !isCurrency && <span style={{ fontSize: 'var(--text-sm)', color: 'var(--text-muted)' }}>{unit}</span>}
      </div>
      {(helperText || error) && (
        <span style={{ fontSize: 'var(--text-xs)', color: error ? 'var(--danger-500)' : 'var(--text-muted)' }}>{error || helperText}</span>
      )}
    </label>
  );
}
