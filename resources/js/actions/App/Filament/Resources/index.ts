import Categories from './Categories'
import ImportMappings from './ImportMappings'
import Organizations from './Organizations'
import Subcategories from './Subcategories'
import Transactions from './Transactions'
import Users from './Users'

const Resources = {
    Categories: Object.assign(Categories, Categories),
    ImportMappings: Object.assign(ImportMappings, ImportMappings),
    Organizations: Object.assign(Organizations, Organizations),
    Subcategories: Object.assign(Subcategories, Subcategories),
    Transactions: Object.assign(Transactions, Transactions),
    Users: Object.assign(Users, Users),
}

export default Resources