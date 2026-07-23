export interface TabEntry { id: string; label: string; }
export interface TabsProps {
  tabs: TabEntry[];
  activeId: string;
  onChange?: (id: string) => void;
}
