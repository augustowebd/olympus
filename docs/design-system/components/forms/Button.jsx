import React from 'react';

const sizes = {
  md: { padding: '8px 16px', fontSize: 'var(--text-sm)', minHeight: '44px' },
  sm: { padding: '6px 12px', fontSize: 'var(--text-xs)', minHeight: '36px' },
};

const variants = {
  primary: { background: 'var(--primary-600)', color: 'var(--text-on-primary)', border: '1px solid var(--primary-600)' },
  secondary: { background: 'var(--bg-surface)', color: 'var(--text-primary)', border: '1px solid var(--border-default)' },
  ghost: { background: 'transparent', color: 'var(--primary-600)', border: '1px solid transparent' },
  danger: { background: 'var(--danger-500)', color: 'var(--text-on-primary)', border: '1px solid var(--danger-500)' },
};

export function Button({ children, variant = 'primary', size = 'md', icon, disabled, onClick, fullWidth }) {
  const v = variants[variant] || variants.primary;
  return (
    <button
      onClick={disabled ? undefined : onClick}
      disabled={disabled}
      style={{
        display: 'inline-flex', alignItems: 'center', justifyContent: 'center', gap: 8,
        fontFamily: 'var(--font-sans)', fontWeight: 'var(--weight-medium)',
        borderRadius: 'var(--radius-sm)', cursor: disabled ? 'not-allowed' : 'pointer',
        opacity: disabled ? 0.5 : 1, transition: 'filter var(--duration-fast) var(--ease-standard)',
        width: fullWidth ? '100%' : undefined,
        ...sizes[size], ...v,
      }}
      onMouseEnter={(e) => { if (!disabled) e.currentTarget.style.filter = 'brightness(0.94)'; }}
      onMouseLeave={(e) => { e.currentTarget.style.filter = 'none'; }}
    >
      {icon && <span aria-hidden="true">{icon}</span>}
      {children}
    </button>
  );
}
