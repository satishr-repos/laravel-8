import IncomeExpenseReport from './components/FinPlan/IncomeExpenseReport.vue'
import BalanceSheet from './components/FinPlan/BalanceSheet.vue'
import GoalsReport from './components/FinPlan/GoalsReport.vue'
import RiskManagement from './components/FinPlan/RiskManagement.vue'
import LivingExpense from './components/FinPlan/LivingExpense.vue'
import EpfReport from './components/FinPlan/EpfReport.vue'
import CashFlowReport from './components/FinPlan/CashFlowReport.vue'
import DownloadReport from './components/FinPlan/DownloadReport.vue'

import RealEstate from './components/Asset/RealEstate.vue'
import PersonalAsset from './components/Asset/PersonalAsset.vue'
import BankAsset from './components/Asset/BankAsset.vue'
import FixedAsset from './components/Asset/FixedAsset.vue'
import InvestmentAsset from './components/Asset/InvestmentAsset.vue'
import RetirementAsset from './components/Asset/RetirementAsset.vue'

const routes = [
        { path: '/iereport/:route', name: 'IEReport', component: IncomeExpenseReport, props: true},
        { path: '/balancesheet/:route', name: 'BalanceSheet', component: BalanceSheet, props: true},
        { path: '/goalsreport/:route', name: 'GoalsReport', component: GoalsReport, props: true},
        { path: '/riskmanagement/:route', name: 'RiskManagement', component: RiskManagement, props: true},
        { path: '/livingexpense/:route', name: 'LivingExpense', component: LivingExpense, props: true},
        { path: '/epfreport/:route', name: 'EpfReport', component: EpfReport, props: true},
        { path: '/cashflowreport/:route', name: 'CashFlowReport', component: CashFlowReport, props: true},
        { path: '/downloadreport/:route', name: 'DownloadReport', component: DownloadReport, props: true},

        { path: '/realestate/:baseRoute', name: 'RealEstate', component: RealEstate, props: true},
        { path: '/personalasset/:baseRoute', name: 'PersonalAsset', component: PersonalAsset, props: true},
        { path: '/bankasset/:baseRoute', name: 'BankAsset', component: BankAsset, props: true},
        { path: '/fixedasset/:baseRoute', name: 'FixedAsset', component: FixedAsset, props: true},
        { path: '/investmentasset/:baseRoute', name: 'InvestmentAsset', component: InvestmentAsset, props: true},
        { path: '/retirementasset/:baseRoute', name: 'RetirementAsset', component: RetirementAsset, props: true},
    ];

export default routes;