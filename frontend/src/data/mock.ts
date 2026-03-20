export const dashboardMetrics = [
  { label: 'Revenue', value: '18.65M', delta: '+12.4%', tone: 'teal' },
  { label: 'Profit', value: '4.72M', delta: '+8.1%', tone: 'amber' },
  { label: 'Collected', value: '14.40M', delta: '+5.2%', tone: 'slate' },
  { label: 'Debt', value: '2.98M', delta: '-3.4%', tone: 'rose' },
] as const

export const quickActions = [
  { label: 'New order', to: '/pos', hint: 'Fast checkout' },
  { label: 'Products', to: '/products', hint: 'Stock control' },
  { label: 'Customers', to: '/customers', hint: 'Debt tracking' },
  { label: 'Reports', to: '/reports', hint: 'Profit and revenue' },
]

export const lowStockItems = [
  { sku: 'SP-001', name: 'Coffee milk bottle', stock: 4 },
  { sku: 'SP-024', name: 'Peach tea large', stock: 7 },
  { sku: 'SP-086', name: 'Drink yogurt', stock: 5 },
]

export const cartItems = [
  { id: 1, name: 'Coffee milk bottle', qty: 2, price: 32000 },
  { id: 2, name: 'Peach tea large', qty: 1, price: 45000 },
  { id: 3, name: 'Fresh milk cake', qty: 3, price: 18000 },
]

export const orders = [
  { id: '#OD-2104', customer: 'Nguyen Hoa', total: '420,000', status: 'Debt', time: '09:20' },
  { id: '#OD-2103', customer: 'Tran An', total: '185,000', status: 'Paid', time: '08:54' },
  { id: '#OD-2102', customer: 'Le Minh', total: '560,000', status: 'Packing', time: '08:30' },
]

export const products = [
  { name: 'Coffee milk bottle', unit: 'Bottle', stock: 4, category: 'Drink' },
  { name: 'Peach tea large', unit: 'Cup', stock: 7, category: 'Drink' },
  { name: 'Fresh milk cake', unit: 'Box', stock: 18, category: 'Bakery' },
]

export const customers = [
  { name: 'Nguyen Hoa', purchases: 42, debt: '1,240,000' },
  { name: 'Tran An', purchases: 18, debt: '0' },
  { name: 'Pham Gia', purchases: 27, debt: '680,000' },
]

export const reportCards = [
  { title: 'This week', value: '52.4M', note: 'Revenue, cached for 15m' },
  { title: 'Gross margin', value: '27.5%', note: 'Profit trend from sold goods' },
  { title: 'Debt collected', value: '4.2M', note: 'Cashflow recovered this week' },
]

export const moduleStates = [
  { key: 'auth', label: 'Auth and JWT', status: 'foundation ready' },
  { key: 'dashboard', label: 'Dashboard', status: 'ui seeded' },
  { key: 'pos', label: 'POS checkout', status: 'ui seeded' },
  { key: 'orders', label: 'Orders and history', status: 'next' },
  { key: 'products', label: 'Products and stock', status: 'next' },
  { key: 'customers', label: 'Customers and debt', status: 'next' },
  { key: 'reports', label: 'Reports cache', status: 'planned' },
  { key: 'utilities', label: 'Migration and health', status: 'foundation ready' },
]