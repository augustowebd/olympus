import React from 'react';

function formatDatePt(raw) {
  const digits = raw.replace(/\D/g, '').slice(0, 8);
  const parts = [];
  if (digits.length > 0) parts.push(digits.slice(0, 2));
  if (digits.length > 2) parts.push(digits.slice(2, 4));
  if (digits.length > 4) parts.push(digits.slice(4, 8));
  return parts.join('/');
}

// Masked dd/mm/aaaa text input + calendar popover grid. Never a native <input type="date">.
export function DatePicker({ label, value, onChange, required, disabled, open, onToggle, calendarMonth = [], selectedDay }) {
  return (
    <div style={{ display: 'flex', flexDirection: 'column', gap: 6, fontFamily: 'var(--font-sans)', width: '100%', position: 'relative' }}>
      {label && <span style={{ fontSize: 'var(--text-sm)', fontWeight: 'var(--weight-medium)', color: 'var(--text-secondary)' }}>{label}{required && <span style={{ color: 'var(--danger-500)' }}> *</span>}</span>}
      <div onClick={disabled ? undefined : onToggle} style={{ display: 'flex', alignItems: 'center', gap: 8, minHeight: 'var(--tap-target-min)', padding: '0 14px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border-default)', background: disabled ? 'var(--bg-sunken)' : 'var(--bg-surface)', cursor: disabled ? 'not-allowed' : 'pointer' }}>
        <input
          type="text" inputMode="numeric" placeholder="dd/mm/aaaa" maxLength={10}
          value={value} disabled={disabled}
          onChange={(e) => onChange && onChange(formatDatePt(e.target.value))}
          style={{ flex: 1, border: 'none', outline: 'none', fontSize: 'var(--text-base)', fontFamily: 'var(--font-sans)', color: disabled ? 'var(--text-secondary)' : 'var(--text-primary)', background: 'transparent', minHeight: 'var(--tap-target-min)' }}
        />
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round">
          <rect x="3" y="5" width="18" height="16" rx="2" /><line x1="3" y1="10" x2="21" y2="10" /><line x1="8" y1="3" x2="8" y2="7" /><line x1="16" y1="3" x2="16" y2="7" />
        </svg>
      </div>
      {open && (
        <div style={{ position: 'absolute', top: 'calc(100% + 6px)', left: 0, zIndex: 20, background: 'var(--bg-surface)', border: '1px solid var(--border-subtle)', borderRadius: 'var(--radius-lg)', boxShadow: 'var(--shadow-lg)', padding: 16, width: 260 }}>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7,1fr)', gap: 4, fontSize: 'var(--text-xs)', color: 'var(--text-muted)', marginBottom: 6, textAlign: 'center' }}>
            {['D', 'S', 'T', 'Q', 'Q', 'S', 'S'].map((d, i) => <span key={i}>{d}</span>)}
          </div>
          <div style={{ display: 'grid', gridTemplateColumns: 'repeat(7,1fr)', gap: 4 }}>
            {calendarMonth.map((day, i) => (
              <span key={i} style={{ height: 30, display: 'flex', alignItems: 'center', justifyContent: 'center', borderRadius: 'var(--radius-md)', fontSize: 'var(--text-sm)', cursor: day ? 'pointer' : 'default', color: day ? 'var(--text-primary)' : 'transparent', background: day === selectedDay ? 'var(--primary-600)' : 'transparent', ...(day === selectedDay ? { color: 'var(--text-on-primary)', fontWeight: 'var(--weight-semibold)' } : {}) }}>
                {day || ''}
              </span>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
