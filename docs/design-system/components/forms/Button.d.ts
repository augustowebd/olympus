export interface ButtonProps {
  /** Button label content */
  children: React.ReactNode;
  /** Visual style */
  variant?: 'primary' | 'secondary' | 'ghost' | 'danger';
  /** Size — md is default tap-target-safe size for field/tablet use */
  size?: 'md' | 'sm';
  /** Optional leading icon element */
  icon?: React.ReactNode;
  disabled?: boolean;
  onClick?: () => void;
  fullWidth?: boolean;
}
