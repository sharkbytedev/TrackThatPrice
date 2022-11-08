<div id="modal" class="fixed top-0 w-full bg-white/30 h-full backdrop-blur-sm">
    <div class="mx-auto my-5 bg-white w-full md:w-2/3 lg:w-1/3 p-3 shadow rounded-md">
        <h1 class="w-full text-center m-5 text-xl">Notice</h1>
        <br>
        <p class="text-center">
            This product is no longer valid, meaning we could not get the required data.
            Please make sure the product still exists at the link you provided. If not, delete this tracker and make a new one with the updated link
        </p>
        <br>
        <p class="text-center">
            If this is a problem on our end, we will be fix it as soon as possible. 
            You can still view the last known product information and historical data, however it will likely become out of date.
        </p>
        <br>
        <div class="w-full justify-center flex">
            <button onclick="hideModal()" class="bg-gray-200 hover:bg-gray-300 p-1 rounded m-auto border border-black m-auto">Dismiss</button>
        </div>
    </div>
    <style>
        .stop-scroll {
            height: 100%;
            overflow: hidden;
        }
    </style>
    <script>
        const disableScroll = () => {
            document.body.classList.add("stop-scroll");
        }
        const enableScroll = () => {
            document.body.classList.remove("stop-scroll");
        }
        const hideModal = () => {
            document.getElementById("modal").style.display = "none";
            enableScroll();
        }
        const showModal = () => {
            document.getElementById("modal").style.display = "block";
            disableScroll();
        }
        // disableScroll();
        document.body.appendChild(document.getElementById("modal"));
        hideModal();
    </script>
</div>