import React from 'react';

const tones = {
  neutral: { background: 'var(--n-100)', color: 'var(--n-700)' },
  primary: { background: 'var(--primary-100)', color: 'var(--primary-700)' },
  success: { background: 'var(--accent-100)', color: 'var(--accent-600)' },
  warning: { background: 'var(--warning-100)', color: 'var(--warning-700)' },
  danger: { background: 'var(--danger-100)', color: 'var(--danger-700)' },
};

export function Badge({ children, tone = 'neutral' }) {
  const t = tones[tone] || tones.neutral;
  return (
    <span style={{ display: 'inline-flex', alignItems: 'center', padding: '4px 12px', borderRadius: 'var(--radius-full)', fontFamily: 'var(--font-sans)', fontSize: 'var(--text-xs)', fontWeight: 'var(--weight-semibold)', ...t }}>
      {children}
    </span>
  );
}
