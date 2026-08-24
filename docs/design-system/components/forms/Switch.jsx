import React from 'react';

export function Switch({ label, checked, onChange }) {
  return (
    <label className="ds-switch">
      <input
        type="checkbox"
        checked={checked}
        onChange={(event) => onChange && onChange(event.target.checked)}
      />
      <span className="ds-switch__trilho" aria-hidden="true"><span /></span>
      {label && <span className="ds-switch__rotulo">{label}</span>}
    </label>
  );
}
