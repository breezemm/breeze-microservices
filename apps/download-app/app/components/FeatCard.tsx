import { IoIosCheckmarkCircle } from "react-icons/io";

const FeatCard = ({
  lists,
  title,
  shortDes,
}: {
  lists: ListInterface[];
  title: string;
  shortDes: string;
}) => {
  return (
    <div className="relative rounded-xl border-[1px] border-primary p-8">
      <div className="absolute -top-6 left-1/2 w-[50%] -translate-x-1/2 rounded-md bg-primary px-3 py-2 text-center text-neutral-1 md:w-[40%]">
        <p>{title}</p>
      </div>
      <ul className="mb-8 flex flex-col gap-4">
        {lists.map((list: ListInterface) => {
          return (
            <li key={list.id}>
              <div className="flex items-center gap-4 relative">
                <IoIosCheckmarkCircle size={22} />
                <p className="w-[80%]">{list.title}</p>
                {list.tag && (
                  <div className="absolute -right-12 rounded-full bg-green-6 px-3 py-1">
                    <p className="text-sm uppercase text-neutral-1">
                      {list.tag?.title}
                    </p>
                  </div>
                )}
              </div>
            </li>
          );
        })}
      </ul>
      <div className="flex justify-center">
        <div className="rounded-full border-[1px] border-blue-7 bg-blue-2 px-6 py-2">
          <p>{shortDes}</p>
        </div>
      </div>
    </div>
  );
};

export default FeatCard;
