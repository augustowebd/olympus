export interface DialogProps {
  open: boolean;
  title: string;
  children: React.ReactNode;
  onClose?: () => void;
  actions?: React.ReactNode;
  /** Dialog width in px. Default 420; use ~640 for multi-column forms. */
  width?: number;
}
