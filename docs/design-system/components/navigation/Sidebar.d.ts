export interface SidebarNavEntry {
  id: string;
  icon: React.ReactNode;
  label: string;
  badge?: string | number;
}
export interface SidebarProps {
  items: SidebarNavEntry[];
  activeId?: string;
  onSelect?: (id: string) => void;
  farmName?: string;
}
