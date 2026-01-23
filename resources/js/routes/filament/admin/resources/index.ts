import categories from './categories'
import importMappings from './import-mappings'
import subcategories from './subcategories'
import transactions from './transactions'
import users from './users'

const resources = {
    categories: Object.assign(categories, categories),
    importMappings: Object.assign(importMappings, importMappings),
    subcategories: Object.assign(subcategories, subcategories),
    transactions: Object.assign(transactions, transactions),
    users: Object.assign(users, users),
}

export default resources