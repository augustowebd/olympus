import React from 'react';

const tones = {
  success: { border: 'var(--accent-500)', bg: 'var(--accent-50)', color: 'var(--accent-600)' },
  warning: { border: 'var(--warning-500)', bg: 'var(--warning-100)', color: 'var(--warning-700)' },
  danger: { border: 'var(--danger-500)', bg: 'var(--danger-100)', color: 'var(--danger-700)' },
  info: { border: 'var(--primary-500)', bg: 'var(--primary-50)', color: 'var(--primary-700)' },
};

export function Toast({ message, tone = 'info', onClose }) {
  const t = tones[tone] || tones.info;
  return (
    <div style={{ display: 'flex', alignItems: 'center', gap: 12, padding: '14px 18px', borderRadius: 'var(--radius-md)', background: t.bg, borderLeft: `4px solid ${t.border}`, boxShadow: 'var(--shadow-md)', fontFamily: 'var(--font-sans)', maxWidth: 380 }}>
      <span style={{ color: t.color, fontSize: 'var(--text-base)', fontWeight: 'var(--weight-medium)', flex: 1 }}>{message}</span>
      {onClose && <button onClick={onClose} style={{ border: 'none', background: 'none', color: t.color, cursor: 'pointer', fontSize: 'var(--text-lg)' }}>×</button>}
    </div>
  );
}
