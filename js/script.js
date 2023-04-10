const togetherData = document.getElementById('together');
const hisBirthday = document.getElementById('hisBirthday');
const herBirthday = document.getElementById('herBirthday');
const kiss = document.getElementById('kiss');
const heixiu = document.getElementById('heixiu');
const embrace = document.getElementById('embrace');
const hand = document.getElementById('hand');
const makeCake = document.getElementById('makeCake');
let loveData;

async function fetchLoveData() {
    if (loveData !== undefined) {//已读取到数据，更新展示数据
        togetherData.innerHTML = await timeDiff(loveData.togetherTime, new Date());
        hisBirthday.innerHTML = await timeDiff(loveData.hisBirthdayTime, new Date());
        herBirthday.innerHTML = await timeDiff(loveData.herBirthdayTime, new Date());
        kiss.innerHTML = await timeDiff(loveData.kissTime, new Date());
        heixiu.innerHTML = await timeDiff(loveData.makeLoveTime, new Date());
        hand.innerHTML = await timeDiff(loveData.handTime, new Date());
        embrace.innerHTML = await timeDiff(loveData.embraceTime, new Date());
        makeCake.innerHTML = await timeDiff(loveData.makeCakeTime, new Date());
        return;
    } else {
        console.log("正在加载数据");
    }
    const response = await fetch("https://api.npmcow.com/post/getLoveData", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    });
    // 解析响应结果
    const result = await response.json();
    if (response.ok) {
        loveData = result;
        console.log(result)
    }
}

window.onload = setInterval(async () => {
    await fetchLoveData()
}, 1000);





async function timeDiff(start, end) {
    const diff = Date.parse(end) - Date.parse(start);
    const seconds = Math.floor(diff / 1000);
    const minutes = Math.floor(seconds / 60);
    const hours = Math.floor(minutes / 60);
    const days = Math.floor(hours / 24);
    return `<span class="underline">${Math.abs(days)}</span>天<span class="underline">${Math.abs(hours % 24)}</span>小时
    <span class="underline">${Math.abs(minutes % 60)}</span>分钟<span class="underline">${Math.abs(seconds % 60)}</span>秒`;
}
