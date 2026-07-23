export interface DatePickerProps {
  label?: string;
  value: string;
  onChange: (value: string) => void;
  required?: boolean;
  disabled?: boolean;
  open?: boolean;
  onToggle?: () => void;
  calendarMonth?: (number | null)[];
  selectedDay?: number;
}
