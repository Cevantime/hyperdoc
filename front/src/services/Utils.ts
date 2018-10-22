class Utils {
    public serialize(obj: any): string {
        return this.serializeRec(obj, '');
    }

    protected serializeRec (obj: any, prefix: string): string {
        var str = [],
            p;
        for (p in obj) {
            if (obj.hasOwnProperty(p)) {
                var k = prefix ? prefix + "[" + p + "]" : p,
                    v = obj[p];
                str.push((v !== null && typeof v === "object")
                    ? this.serializeRec(v, k)
                    : encodeURIComponent(k) + "=" + encodeURIComponent(v));
            }
        }
        return str.join("&");
    }
}

export default new Utils;