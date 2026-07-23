export interface ToastProps {
  message: string;
  tone?: 'success' | 'warning' | 'danger' | 'info';
  onClose?: () => void;
}
