export interface StatCardProps {
  label: string;
  value: string | number;
  unit?: string;
  /** Signed delta text, e.g. "+3.2%" or "-1.1%" */
  delta?: string;
  icon?: React.ReactNode;
}
