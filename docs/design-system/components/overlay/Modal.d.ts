export interface ModalProps {
  open: boolean;
  title: string;
  children: React.ReactNode;
  onClose: () => void;
  actions?: React.ReactNode;
  width?: number;
}
