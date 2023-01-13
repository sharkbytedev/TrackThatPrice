const { exit } = require("process");
const puppeteer = require("puppeteer");
const yargs = require("yargs");


const options = yargs.option("h", {alias: "html", type: "string"}).argv;
// const options = yargs.option("html", {type: string}).argv;

const renderHtml = async (urls) => {
    const browser = await puppeteer.launch();
    const page = await browser.newPage();
    
    output = {}
    for (const url of urls) {
        // console.log(url)
        // await page.setContent(html);
        try {
            let status = await page.goto(url, {timeout: 40000});
            status = status.status();

            if (status != 200) {
                output[url] = status;
                continue;
            }
            output[url] = await page.content();
        }
        catch (e) {
            if (e instanceof puppeteer.TimeoutError) {
                output[url] = null;
            }
            else {
                throw e;
            }
        }
    }

    return output;
}
let tryCount = 1;
const main = () => {
    renderHtml(options.html.split("[]"))
    .then(content => {
        process.stdout.write(JSON.stringify(content));
        exit();
    })
}

main()