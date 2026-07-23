import React from 'react';

const paths = {
  dashboard: (
    <React.Fragment>
      <rect x="3" y="3" width="7.5" height="7.5" rx="1.5" />
      <rect x="13.5" y="3" width="7.5" height="7.5" rx="1.5" />
      <rect x="3" y="13.5" width="7.5" height="7.5" rx="1.5" />
      <rect x="13.5" y="13.5" width="7.5" height="7.5" rx="1.5" />
    </React.Fragment>
  ),
  egg: <ellipse cx="12" cy="13" rx="7" ry="9" />,
  animal: (
    <React.Fragment>
      <circle cx="11" cy="13" r="8" />
      <path d="M19 11l3-2-1 4" />
    </React.Fragment>
  ),
  feed: (
    <React.Fragment>
      <line x1="12" y1="3" x2="12" y2="21" />
      <line x1="12" y1="6" x2="7" y2="9" />
      <line x1="12" y1="6" x2="17" y2="9" />
      <line x1="12" y1="12" x2="7" y2="15" />
      <line x1="12" y1="12" x2="17" y2="15" />
    </React.Fragment>
  ),
  box: (
    <React.Fragment>
      <rect x="4" y="8" width="16" height="12" rx="1" />
      <line x1="4" y1="8" x2="12" y2="3" />
      <line x1="20" y1="8" x2="12" y2="3" />
    </React.Fragment>
  ),
  cart: (
    <React.Fragment>
      <rect x="4" y="6" width="15" height="9" rx="1" />
      <circle cx="8" cy="19" r="1.6" />
      <circle cx="16" cy="19" r="1.6" />
    </React.Fragment>
  ),
  truck: (
    <React.Fragment>
      <rect x="2" y="8" width="12" height="9" rx="1" />
      <rect x="14" y="11" width="7" height="6" rx="1" />
      <circle cx="7" cy="19" r="1.6" />
      <circle cx="17" cy="19" r="1.6" />
    </React.Fragment>
  ),
  dollar: (
    <React.Fragment>
      <circle cx="12" cy="12" r="9" />
      <line x1="12" y1="7" x2="12" y2="17" />
      <path d="M9.5 9.8c0-1.3 1.2-2.2 2.5-2.2s2.5.7 2.5 1.8-1.1 1.6-2.5 1.9-2.5.8-2.5 1.9 1.2 1.8 2.5 1.8 2.5-.9 2.5-2.2" />
    </React.Fragment>
  ),
  wrench: (
    <React.Fragment>
      <circle cx="6" cy="6" r="3" />
      <rect x="9.5" y="10.5" width="12" height="4" rx="1" transform="rotate(45 9.5 10.5)" />
      <circle cx="18" cy="18" r="3" />
    </React.Fragment>
  ),
  users: (
    <React.Fragment>
      <circle cx="9" cy="9" r="4" />
      <circle cx="16" cy="11" r="3.2" />
      <path d="M3 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
      <path d="M14 20c0-2.6 1.8-4.8 4.2-5.5" />
    </React.Fragment>
  ),
  chart: (
    <React.Fragment>
      <rect x="4" y="12" width="4" height="8" rx="0.5" />
      <rect x="10" y="7" width="4" height="13" rx="0.5" />
      <rect x="16" y="3" width="4" height="17" rx="0.5" />
    </React.Fragment>
  ),
  alert: (
    <React.Fragment>
      <path d="M12 3l10 18H2z" />
      <line x1="12" y1="10" x2="12" y2="14.5" />
      <circle cx="12" cy="17.5" r="0.9" fill="currentColor" stroke="none" />
    </React.Fragment>
  ),
  eye: (
    <React.Fragment>
      <path d="M2 12c2.5-5 7-8 10-8s7.5 3 10 8c-2.5 5-7 8-10 8s-7.5-3-10-8z" />
      <circle cx="12" cy="12" r="3" />
    </React.Fragment>
  ),
  edit: (
    <React.Fragment>
      <path d="M4 20l1-4.5L15.5 5 19 8.5 8.5 19z" />
      <line x1="13" y1="7" x2="17" y2="10.5" />
    </React.Fragment>
  ),
  power: (
    <React.Fragment>
      <line x1="12" y1="3" x2="12" y2="11" />
      <path d="M6.5 6.5a8 8 0 1 0 11 0" />
    </React.Fragment>
  ),
  trash: (
    <React.Fragment>
      <line x1="4" y1="7" x2="20" y2="7" />
      <path d="M6 7l1 13h10l1-13" />
      <line x1="9.5" y1="3.5" x2="14.5" y2="3.5" />
      <line x1="9.5" y1="3.5" x2="9.5" y2="7" />
      <line x1="14.5" y1="3.5" x2="14.5" y2="7" />
    </React.Fragment>
  ),
  file: (
    <React.Fragment>
      <path d="M6 2h9l3 3v17H6z" />
      <path d="M15 2v3h3" />
      <line x1="9" y1="12" x2="15" y2="12" />
      <line x1="9" y1="16" x2="15" y2="16" />
    </React.Fragment>
  ),
  info: (
    <React.Fragment>
      <circle cx="12" cy="12" r="9" />
      <line x1="12" y1="11" x2="12" y2="16" />
      <circle cx="12" cy="7.5" r="0.9" fill="currentColor" stroke="none" />
    </React.Fragment>
  ),
};

export function Icon({ name, size = 22, strokeWidth = 1.8, color = 'currentColor' }) {
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none" stroke={color} strokeWidth={strokeWidth} strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
      {paths[name] || <circle cx="12" cy="12" r="9" />}
    </svg>
  );
}
