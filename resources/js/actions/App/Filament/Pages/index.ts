import Breakdown from './Breakdown'
import Dashboard from './Dashboard'
import MonthlySummary from './MonthlySummary'

const Pages = {
    Breakdown: Object.assign(Breakdown, Breakdown),
    Dashboard: Object.assign(Dashboard, Dashboard),
    MonthlySummary: Object.assign(MonthlySummary, MonthlySummary),
}

export default Pages