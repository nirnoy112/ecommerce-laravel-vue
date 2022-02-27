import {customerRoutes} from './customer/routes';
import {pageRoutes} from './pages/routes';
import {ecommerceRoutes} from './ecommerce/routes';

const routesArray = [];
routesArray.push(...customerRoutes);
routesArray.push(...pageRoutes);
routesArray.push(...ecommerceRoutes);

export const routes = routesArray;
