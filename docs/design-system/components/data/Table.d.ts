export interface TableColumn { key: string; label: string; align?: 'left' | 'center' | 'right'; }
export interface TableProps {
  columns: TableColumn[];
  rows: Record<string, React.ReactNode>[];
}
