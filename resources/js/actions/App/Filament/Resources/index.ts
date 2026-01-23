import Categories from './Categories'
import ImportMappings from './ImportMappings'
import Subcategories from './Subcategories'
import Transactions from './Transactions'
import Users from './Users'

const Resources = {
    Categories: Object.assign(Categories, Categories),
    ImportMappings: Object.assign(ImportMappings, ImportMappings),
    Subcategories: Object.assign(Subcategories, Subcategories),
    Transactions: Object.assign(Transactions, Transactions),
    Users: Object.assign(Users, Users),
}

export default Resources