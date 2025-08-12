export interface ZiggyConfig {
    url: string;
    port: number | null;
    defaults: object;
    routes: object;
}

declare global {
    var Ziggy: ZiggyConfig;
}
