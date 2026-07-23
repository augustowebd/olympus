export interface InputProps {
  label?: string;
  placeholder?: string;
  value?: string;
  onChange?: (e: React.ChangeEvent<HTMLInputElement>) => void;
  type?: 'text' | 'number' | 'email' | 'password' | 'date' | 'currency';
  helperText?: string;
  error?: string;
  icon?: React.ReactNode;
  /** Trailing unit label, e.g. "kg", "un" */
  unit?: string;
  /** Shows a red asterisk after the label */
  required?: boolean;
  /** Renders read-only (sunken background, muted text) */
  disabled?: boolean;
}
