import React from "react";
import { LuDownload } from "react-icons/lu";
const DownloadButton = () => {
  return (
    <div>
      <button className="hidden h-11 flex  w-40 rounded-md bg-neutral-9 text-center  text-neutral-1  md:block ">
        Download Free
      </button>

      <div className="flex h-10 w-10 items-center justify-center rounded-md bg-green-6 md:hidden">
        <LuDownload className="text-white" />
      </div>
    </div>
  );
};

export default DownloadButton;
