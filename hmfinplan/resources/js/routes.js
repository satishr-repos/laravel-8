import IncomeExpenseReport from './components/FinPlan/IncomeExpenseReport.vue'
import BalanceSheet from './components/FinPlan/BalanceSheet.vue'
import GoalsReport from './components/FinPlan/GoalsReport.vue'
import RiskManagement from './components/FinPlan/RiskManagement.vue'
import LivingExpense from './components/FinPlan/LivingExpense.vue'
import EpfReport from './components/FinPlan/EpfReport.vue'
import CashFlowReport from './components/FinPlan/CashFlowReport.vue'

const routes = [
        { path: '/iereport/:route', name: 'IEReport', component: IncomeExpenseReport, props: true},
        { path: '/balancesheet/:route', name: 'BalanceSheet', component: BalanceSheet, props: true},
        { path: '/goalsreport/:route', name: 'GoalsReport', component: GoalsReport, props: true},
        { path: '/riskmanagement/:route', name: 'RiskManagement', component: RiskManagement, props: true},
        { path: '/livingexpense/:route', name: 'LivingExpense', component: LivingExpense, props: true},
        { path: '/epfreport/:route', name: 'EpfReport', component: EpfReport, props: true},
        { path: '/cashflowreport/:route', name: 'CashFlowReport', component: CashFlowReport, props: true}
    ];

export default routes;