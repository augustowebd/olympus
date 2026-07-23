export interface SelectOption { value: string; label: string; }
export interface SelectProps {
  label?: string;
  value?: string;
  onChange?: (e: React.ChangeEvent<HTMLSelectElement>) => void;
  options: SelectOption[];
  placeholder?: string;
  /** Shows a red asterisk after the label */
  required?: boolean;
  /** Renders read-only (sunken background, muted text) */
  disabled?: boolean;
}
