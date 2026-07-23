import React from 'react';

export function Progress({ value, label, tone = 'primary' }) {
  const tones = {
    primary: 'var(--primary-600)',
    success: 'var(--accent-500)',
    warning: 'var(--warning-500)',
    danger: 'var(--danger-500)',
  };
  const pct = Math.max(0, Math.min(100, value));
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 6, fontFamily: 'var(--font-sans)', width: '100%' }}>
      {label && (
        <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: 'var(--text-sm)', color: 'var(--text-secondary)' }}>
          <span>{label}</span>
          <span style={{ fontWeight: 'var(--weight-semibold)', color: 'var(--text-primary)' }}>{pct}%</span>
        </div>
      )}
      <div style={{ height: 10, borderRadius: 'var(--radius-full)', background: 'var(--n-100)', overflow: 'hidden' }}>
        <div style={{ height: '100%', width: `${pct}%`, background: tones[tone] || tones.primary, borderRadius: 'var(--radius-full)', transition: 'width .3s ease' }} />
      </div>
    </div>
  );
}
